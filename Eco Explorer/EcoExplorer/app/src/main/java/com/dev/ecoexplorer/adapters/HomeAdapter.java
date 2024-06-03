package com.dev.ecoexplorer.adapters;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.dev.ecoexplorer.R;
import com.dev.ecoexplorer.databinding.ItemHomeBinding;

public class HomeAdapter extends RecyclerView.Adapter<HomeAdapter.Vh> {
    String [] arr={"Route Planning","Weather & Traffic Alerts","Expense Tracker","Carbon Calculator"};
    int [] icons={R.drawable.route,R.drawable.route,R.drawable.stats,R.drawable.stats};
    OnItemClick onItemClick;

    public HomeAdapter(OnItemClick onItemClick) {
        this.onItemClick = onItemClick;
    }

    @NonNull
    @Override
    public Vh onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
       View view= LayoutInflater.from(parent.getContext()).inflate(R.layout.item_home,parent,false);
       return new Vh(view);
    }

    @Override
    public void onBindViewHolder(@NonNull Vh holder, int position) {
        String title=arr[position];
        int icon=icons[position];
        holder.binding.image.setImageResource(icon);
        holder.binding.tvTitle.setText(title);

        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onItemClick.onClick(position);
            }
        });

    }

    @Override
    public int getItemCount() {
        return arr.length;
    }

    public static class Vh extends RecyclerView.ViewHolder {
        ItemHomeBinding binding;
        public Vh(@NonNull View itemView) {
            super(itemView);
            binding=ItemHomeBinding.bind(itemView);
        }
    }
    public interface OnItemClick{
        public void onClick(int pos);
    }
}
